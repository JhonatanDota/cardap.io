import { Link } from "react-router-dom";

import { MdEmail, MdLock } from "react-icons/md";

export default function Register() {
  return (
    <div className="flex flex-col items-center gap-8 mt-16 m-auto">
      <img
        className="w-64 md:w-80"
        src="/images/logos/CardapioLogoBlack.svg"
        alt="Cardap.io"
      />
      <form className="flex flex-col p-4 gap-8 rounded-md">
        <div className="flex flex-col self-end">
          <p className="text-xl md:text-2xl font-medium">Registrar-se</p>
          <hr className="w-1/2 h-1 bg-[#F97316]" />
        </div>

        <div className="flex flex-col gap-5 md:gap-8">
          <div className="border-b-2 border-gray-300 focus-within:border-[#7D2AE8] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdEmail className="w-7 h-7" fill="#7D2AE8" />
              <input
                type="text"
                placeholder="Email"
                className="text-lg md:text-xl focus:outline-none w-full"
                autoComplete="off"
              />
            </div>
          </div>

          <div className="border-b-2 border-gray-300 focus-within:border-[#7D2AE8] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdLock className="w-7 h-7" fill="#7D2AE8" />
              <input
                type="password"
                placeholder="Senha"
                className="text-lg md:text-xl focus:outline-none w-full"
              />
            </div>
          </div>

          <div className="border-b-2 border-gray-300 focus-within:border-[#7D2AE8] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdLock className="w-7 h-7" fill="#7D2AE8" />
              <input
                type="password"
                placeholder="Confirme sua senha"
                className="text-lg md:text-xl focus:outline-none w-full"
              />
            </div>
          </div>
        </div>

        <button
          type="submit"
          className="bg-[#F97316] p-4 text-base font-bold uppercase text-white rounded-md"
        >
          Registrar-se
        </button>
      </form>

      <span className="text-base font-medium">
        Já possui uma conta?{" "}
        <Link className="folt-bold text-[#7D2AE8]" to="/login">
          Faça o Login!
        </Link>
      </span>
    </div>
  );
}
