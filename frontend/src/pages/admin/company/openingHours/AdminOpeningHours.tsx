import { useEffect } from "react";

import { useForm } from "react-hook-form";

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

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<SyncOpeningHoursSchemaType>({
    resolver: zodResolver(syncOpeningHoursSchemaData),
    defaultValues: {
      openingHours: openingHoursConstants,
    },
  });

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
      <MenuPageTitle title="Horários de Funcionamento" />

      <form onSubmit={handleSubmit(onSubmit)} className="grid gap-3">
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

        <div className="flex justify-end">
          <SubmitButton />
        </div>
      </form>
    </MenuPageSectionContainer>
  );
}
