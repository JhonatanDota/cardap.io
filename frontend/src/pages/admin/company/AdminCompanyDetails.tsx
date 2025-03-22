import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";

import { CompanyModel } from "../../../models/companyModels";

import {
  CompanySchemaType,
  companySchemaData,
} from "../forms/schemas/companyDetails";

import MenuPageSectionContainer from "../components/MenuPageSectionContainer";
import TextInput from "../components/inputs/TextInput";
import ImageInput from "../components/inputs/ImageInput";

interface AdminCompanyDetailsProps {
  company: CompanyModel;
}

export default function AdminCompanyDetails(props: AdminCompanyDetailsProps) {
  const { company } = props;

  const {
    register,
    handleSubmit,
    formState: { errors },
    setValue,
  } = useForm<CompanySchemaType>({
    resolver: zodResolver(companySchemaData),
    defaultValues: {
      name: company.name,
      logo: company.logo,
      banner: company.banner,
    },
  });

  function onSubmit(data: CompanySchemaType): void {
    console.log(data);
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <MenuPageSectionContainer>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
          <TextInput
            label="Nome"
            register={register("name")}
            error={errors.name?.message}
          />
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
          <ImageInput
            label="Logo"
            initialImageUrl={company.logo}
            onChange={(imageUrl) => setValue("logo", imageUrl)}
          />
          <ImageInput
            label="Banner"
            initialImageUrl={company.banner}
            onChange={(imageUrl) => setValue("banner", imageUrl)}
          />
        </div>

        <div className="mt-4">
          <button
            type="submit"
            className="px-4 py-2 bg-blue-600 text-white rounded-md"
          >
            Salvar
          </button>
        </div>
      </MenuPageSectionContainer>
    </form>
  );
}
