import { UseFormRegisterReturn } from "react-hook-form";
interface TextInputProps {
  label: string;
  register: UseFormRegisterReturn;
  error?: string;
}

export default function TextInput(props: TextInputProps) {
  const { label, register, error } = props;

  return (
    <div className="flex flex-col gap-1 text-lg md:text-xl">
      <label className="font-medium">{label}</label>
      <input
        className={`border-[2px] font-medium border-gray-900 p-2 shadow-sm transition-colors duration-100 focus:border-purple-800 focus:outline-none ${
          error ? "border-red-500" : ""
        }`}
        type="text"
        autoComplete="off"
        {...register}
      />
      {error && <span className="text-red-500 text-sm">{error}</span>}
    </div>
  );
}
