import { useEffect } from "react";

import { useForm } from "react-hook-form";

import { zodResolver } from "@hookform/resolvers/zod";

import {
  SyncPaymentMethodSchemaType,
  syncPaymentMethodSchemaData,
} from "../../forms/schemas/company/syncPaymentMethod";

import { toast } from "react-hot-toast";
import { CompanyModel } from "../../../../models/companyModels";

import { PaymentMethodEnum } from "../../../../enums/payment";

import {
  getCompanyPaymentMethods,
  syncCompanyPaymentMethods,
} from "../../../../requests/companyRequests";

import { handleErrors } from "../../../../requests/handleErrors";

import MenuPageSectionContainer from "../../components/MenuPageSectionContainer";
import MenuPageTitle from "../../components/MenuPageTitle";

import { paymentMethodsConstant } from "../../../../constants/payment/paymentMethodsConstants";

import AdminPaymentMethodCard from "./AdminPaymentMethodCard";

import SubmitButton from "../../components/buttons/SubmitButton";
interface AdminCompanyPaymentMethodsFormProps {
  company: CompanyModel;
}

export default function AdminPaymentMethods(
  props: AdminCompanyPaymentMethodsFormProps
) {
  const { company } = props;

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<SyncPaymentMethodSchemaType>({
    resolver: zodResolver(syncPaymentMethodSchemaData),
  });

  useEffect(() => {
    fetchPaymentMethods();
  }, []);

  async function onSubmit(data: SyncPaymentMethodSchemaType): Promise<void> {
    const checkedPaymentMethods = Object.keys(data.paymentMethods).filter(
      (key) => data.paymentMethods[key as PaymentMethodEnum]
    );

    try {
      await syncCompanyPaymentMethods(company.id, checkedPaymentMethods);
      toast.success("Formas de pagamento atualizadas!");
    } catch (error) {
      handleErrors(error);
    }
  }

  async function fetchPaymentMethods(): Promise<void> {
    try {
      const response = await getCompanyPaymentMethods(company.id);
      const methods = response.data;

      const defaultValues: SyncPaymentMethodSchemaType = {
        paymentMethods: {},
      };

      methods.forEach((method) => {
        defaultValues.paymentMethods[method.paymentMethod] = true;
      });

      reset(defaultValues);
    } catch (error) {
      handleErrors(error);
    }
  }

  return (
    <MenuPageSectionContainer>
      <MenuPageTitle title="Formas de Pagamento" />

      <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-4">
        <div className="grid md:grid-cols-2 gap-4">
          {paymentMethodsConstant.map((paymentMethod) => (
            <AdminPaymentMethodCard
              key={paymentMethod.slug}
              paymentMethod={paymentMethod}
              register={register(`paymentMethods.${paymentMethod.slug}`)}
            />
          ))}
        </div>
        {errors.paymentMethods && (
          <p className="text-center text-red-500 text-sm md:text-base">
            {(errors.paymentMethods as { message?: string })?.message}
          </p>
        )}

        <div className="flex justify-end">
          <SubmitButton />
        </div>
      </form>
    </MenuPageSectionContainer>
  );
}
