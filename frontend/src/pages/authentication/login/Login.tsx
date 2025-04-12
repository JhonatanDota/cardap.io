import { useForm } from "react-hook-form";

import { Link } from "react-router-dom";

import { zodResolver } from "@hookform/resolvers/zod";

import { handleErrors } from "../../../requests/handleErrors";

import { auth } from "../../../requests/authenticationRequests";

import { loginSchemaData, LoginSchemaType } from "../../../schema/loginSchema";

import { MdEmail, MdLock } from "react-icons/md";

export default function Login() {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<LoginSchemaType>({
    resolver: zodResolver(loginSchemaData),
  });

  async function onSubmit(data: LoginSchemaType): Promise<void> {
    try {
      const loginResponse = await auth(data);
    } catch (error) {
      handleErrors(error);
    }
  }

  return (
    <div className="flex flex-col items-center gap-6 mt-16 m-auto">
      <img
        className="w-64 md:w-80"
        src="/images/logos/CardapioLogoBlack.svg"
        alt="Cardap.io"
      />

      <form
        onSubmit={handleSubmit(onSubmit)}
        className="flex flex-col p-4 gap-8 rounded-md"
      >
        <div className="flex flex-col">
          <p className="text-xl md:text-2xl font-medium">Login</p>
          <hr className="w-1/4 h-1 bg-[#7D2AE8]" />
        </div>

        <div className="flex flex-col gap-5 md:gap-8">
          <div className="border-b-2 border-gray-300 focus-within:border-[#F97316] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdEmail className="w-7 h-7" fill="#F97316" />
              <input
                type="text"
                placeholder="Por favor, insira seu email"
                className="text-lg md:text-xl focus:outline-none w-full"
                autoComplete="off"
                {...register("email")}
              />
            </div>
            {errors.email && (
              <span className="font-bold text-sm text-red-400">
                {errors.email.message}
              </span>
            )}
          </div>

          <div className="border-b-2 border-gray-300 focus-within:border-[#F97316] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdLock className="w-7 h-7" fill="#F97316" />
              <input
                type="password"
                placeholder="Por favor, insira sua senha"
                className="text-lg md:text-xl focus:outline-none w-full"
                {...register("password")}
              />
            </div>
            {errors.password && (
              <span className="font-bold text-sm text-red-400">
                {errors.password.message}
              </span>
            )}
          </div>
        </div>

        <button
          type="submit"
          className="bg-[#7D2AE8] p-4 text-base font-bold uppercase text-white rounded-md"
        >
          Entrar
        </button>
      </form>

      <span className="text-base font-medium">
        Ainda não tem uma conta?{" "}
        <Link className="folt-bold text-[#7D2AE8]" to="/register">
          Registre-se!
        </Link>
      </span>
    </div>
  );
}
