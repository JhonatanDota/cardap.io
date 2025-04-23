import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";

import {
  CompanyModel,
  CreateCompanyModel,
} from "../../../models/companyModels";

import { handleErrors } from "../../../requests/handleErrors";

import { addCompany } from "../../../requests/companyRequests";

import {
  CompanySchemaType,
  companySchemaData,
} from "../forms/schemas/company/createCompany";

import MenuPageSectionContainer from "../components/MenuPageSectionContainer";

import TextInput from "../components/inputs/TextInput";
import MenuPageSectionTitle from "../components/MenuPageSectionTitle";

interface AdminCompanyFormProps {
  company?: CompanyModel;
}

export default function AdminCompanyForm(props: AdminCompanyFormProps) {
  const { company } = props;

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<CompanySchemaType>({
    resolver: zodResolver(companySchemaData),
    defaultValues: {},
  });

  async function onSubmit(data: CompanySchemaType): Promise<void> {
    try {
      await addCompany(data as CreateCompanyModel);
    } catch (error) {
      handleErrors(error);
    }
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <MenuPageSectionContainer>
        <div className="flex flex-col gap-3 md:w-2/3 md:border-2 md:p-4">
          <MenuPageSectionTitle title="Informações Básicas" />

          <div className="flex flex-col gap-3 md:grid md:grid-cols-2">
            <TextInput
              label="Nome"
              register={register("name")}
              error={errors.name?.message}
            />

            <TextInput
              label="CNPJ"
              register={register("cnpj")}
              error={errors.cnpj?.message}
            />

            <TextInput
              label="Email"
              register={register("email")}
              error={errors.email?.message}
            />

            <TextInput
              label="Telefone"
              register={register("phone")}
              error={errors.phone?.message}
            />
          </div>

          <MenuPageSectionTitle title="Endereço" />

          <div className="flex flex-col gap-3 md:grid md:grid-cols-2">
            <TextInput
              label="Rua"
              register={register("street")}
              error={errors.street?.message}
            />

            <TextInput
              label="Número"
              register={register("number")}
              error={errors.number?.message}
            />

            <TextInput
              label="Complemento"
              register={register("complement")}
              error={errors.complement?.message}
            />

            <TextInput
              label="Bairro"
              register={register("neighborhood")}
              error={errors.neighborhood?.message}
            />

            <TextInput
              label="CEP"
              register={register("postalCode")}
              error={errors.postalCode?.message}
            />

            <TextInput
              label="Estado"
              register={register("state")}
              error={errors.state?.message}
            />
          </div>
          <div className="mt-4 self-end">
            <button
              type="submit"
              className="font-bold px-6 py-2 bg-blue-600 text-white "
            >
              Salvar
            </button>
          </div>
        </div>
      </MenuPageSectionContainer>
    </form>
  );
}
