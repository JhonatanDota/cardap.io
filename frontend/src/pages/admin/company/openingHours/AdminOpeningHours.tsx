import { useEffect } from "react";

import { useForm, FormProvider } from "react-hook-form";

import { zodResolver } from "@hookform/resolvers/zod";

import { CompanyModel } from "../../../../models/companyModels";

import { getCompanyOpeningHours } from "../../../../requests/companyRequests";

import { handleErrors } from "../../../../requests/handleErrors";

import {
  syncOpeningHoursSchemaData,
  SyncOpeningHoursSchemaType,
} from "../../forms/schemas/company/syncOpeningHours";

import MenuPageSectionContainer from "../../components/MenuPageSectionContainer";
import MenuPageTitle from "../../components/MenuPageTitle";

import { openingHoursConstants } from "../../../../constants/date/openingHoursConstants";

import AdminOpeningHour from "./AdminOpeningHour";
import SubmitButton from "../../components/buttons/SubmitButton";

interface AdminCompanyOpeningHoursFormProps {
  company: CompanyModel;
}

export default function AdminOpeningHours(
  props: AdminCompanyOpeningHoursFormProps
) {
  const { company } = props;

  const methods = useForm<SyncOpeningHoursSchemaType>({
    resolver: zodResolver(syncOpeningHoursSchemaData),
    defaultValues: {
      openingHours: openingHoursConstants,
    },
  });

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = methods;

  useEffect(() => {
    fetchOpeningHours();
  }, []);

  async function fetchOpeningHours(): Promise<void> {
    try {
      const response = await getCompanyOpeningHours(company.id);

      console.log(response.data);
    } catch (error) {
      handleErrors(error);
    }
  }

  async function onSubmit(data: SyncOpeningHoursSchemaType) {
    console.log(data);
  }

  return (
    <MenuPageSectionContainer>
      <MenuPageTitle title="Horários" />

      <span className="text-sm md:text-base text-blue-700/80 font-medium">
        Para marcar o dia como fechado, defina os horários como 00:00.
      </span>

      <FormProvider {...methods}>
        <form onSubmit={handleSubmit(onSubmit)} className="flex flex-col gap-3">
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
            {openingHoursConstants.map((openingHour, index) => (
              <AdminOpeningHour
                key={openingHour.weekDay}
                openingHour={openingHour}
                registerInit={register(`openingHours.${index}.range.init`)}
                registerEnd={register(`openingHours.${index}.range.end`)}
                errors={{
                  range: errors.openingHours?.[index]?.range,
                  init: errors.openingHours?.[index]?.range?.init,
                  end: errors.openingHours?.[index]?.range?.end,
                }}
              />
            ))}
          </div>

          <div className="flex justify-end">
            <SubmitButton />
          </div>
        </form>
      </FormProvider>
    </MenuPageSectionContainer>
  );
}
