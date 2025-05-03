import { useState, useEffect } from "react";

import { useForm } from "react-hook-form";

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

type PaymentMethodsFormType = {
  [key in PaymentMethodEnum]?: boolean;
};

export default function AdminPaymentMethods(
  props: AdminCompanyPaymentMethodsFormProps
) {
  const { company } = props;

  const { register, handleSubmit, reset } = useForm<PaymentMethodsFormType>();

  useEffect(() => {
    fetchPaymentMethods();
  }, []);

  async function onSubmit(data: PaymentMethodsFormType): Promise<void> {
    const checkedPaymentMethods = Object.keys(data).filter(
      (key) => data[key as PaymentMethodEnum]
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

      const defaultValues: PaymentMethodsFormType = {};

      methods.forEach((method) => {
        defaultValues[method.paymentMethod] = true;
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
        <div className="grid md:grid-cols-2 gap-4 md:gap-6">
          {paymentMethodsConstant.map((paymentMethod) => (
            <AdminPaymentMethodCard
              key={paymentMethod.slug}
              paymentMethod={paymentMethod}
              register={register(paymentMethod.slug)}
            />
          ))}
        </div>

        <div className="flex justify-end">
          <SubmitButton />
        </div>
      </form>
    </MenuPageSectionContainer>
  );
}
