import { MdEmail } from "react-icons/md";
import { MdLock } from "react-icons/md";

export default function Login() {
  return (
    <div className="flex flex-col items-center gap-8 mt-16 m-auto">
      <img
        className="w-64 md:w-80"
        src="/images/logos/CardapioLogoBlack.svg"
        alt="Cardap.io"
      />

      <div className="flex flex-col p-4 gap-8 rounded-md">
        <div className="flex flex-col">
          <p className="text-xl md:text-2xl font-medium">Login</p>
          <hr className="w-1/4 h-1 bg-[#7D2AE8]" />
        </div>

        <div className="flex flex-col gap-5 md:gap-8">
          <div className="border-b-2 border-gray-300  focus-within:border-[#F97316] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdEmail className="w-7 h-7" fill="#F97316" />
              <input
                type="text"
                placeholder="Por favor, insira seu email"
                className="text-lg md:text-xl focus:outline-none"
              />
            </div>
          </div>

          <div className="border-b-2 border-gray-300  focus-within:border-[#F97316] focus-within:shadow-sm transition-colors duration-300">
            <div className="flex items-center gap-3 pb-4">
              <MdLock className="w-7 h-7" fill="#F97316" />
              <input
                type="password"
                placeholder="Por favor, insira sua senha"
                className="text-lg md:text-xl focus:outline-none"
              />
            </div>
          </div>
        </div>

        <button className="bg-[#7D2AE8] p-4 text-base font-bold uppercase text-white rounded-md">
          Entrar
        </button>
      </div>
    </div>
  );
}
