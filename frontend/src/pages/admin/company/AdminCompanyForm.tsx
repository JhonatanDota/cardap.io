import { useEffect } from "react";
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
import {
  cnpjMask,
  phoneMask,
  unmaskCnpj,
  unmaskPhone,
} from "../../../utils/input/masks";

interface AdminCompanyFormProps {
  company: CompanyModel | null;
}

export default function AdminCompanyForm(props: AdminCompanyFormProps) {
  const { company } = props;

  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<CompanySchemaType>({
    resolver: zodResolver(companySchemaData),
  });

  useEffect(() => {
    if (company) {
      reset({
        ...company,
        cnpj: cnpjMask(company.cnpj),
        phone: phoneMask(company.phone),
      });
    }
  }, [company, reset]);

  async function onSubmit(data: CompanySchemaType): Promise<void> {
    try {
      await addCompany({
        ...data,
        cnpj: unmaskCnpj(data.cnpj),
        phone: unmaskPhone(data.phone),
      } as CreateCompanyModel);
    } catch (error) {
      handleErrors(error);
    }
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <MenuPageSectionContainer>
        <div className="flex flex-col gap-3 lg:w-2/3 md:border-2 md:p-4">
          <MenuPageSectionTitle title="Informações Básicas" />

          <div className="flex flex-col gap-4 md:grid md:grid-cols-2">
            <TextInput
              label="Nome"
              register={register("name")}
              error={errors.name?.message}
            />

            <TextInput
              label="CNPJ"
              register={register("cnpj")}
              error={errors.cnpj?.message}
              mask={cnpjMask}
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
              mask={phoneMask}
            />
          </div>

          <MenuPageSectionTitle title="Endereço" />

          <div className="flex flex-col gap-4 md:grid md:grid-cols-2">
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
              label="Cidade"
              register={register("city")}
              error={errors.city?.message}
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
              className="font-bold px-6 py-2 bg-blue-600 hover:bg-blueasds@asdas.com-700 text-white "
            >
              SALVAR
            </button>
          </div>
        </div>
      </MenuPageSectionContainer>
    </form>
  );
}
