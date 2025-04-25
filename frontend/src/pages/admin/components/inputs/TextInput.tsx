import { UseFormRegisterReturn } from "react-hook-form";

import { MaskFunction } from "../../../../utils/input/masks";

interface TextInputProps {
  label: string;
  register: UseFormRegisterReturn;
  error?: string;
  mask?: MaskFunction;
}

export default function TextInput(props: TextInputProps) {
  const { label, register, error, mask } = props;

  const inputClassName = `border-[2px] font-medium border-gray-900 p-2 shadow-sm transition-colors duration-100 focus:border-purple-800 focus:outline-none ${
    error ? "border-red-500" : ""
  }`;

  function handleChange(e: React.ChangeEvent<HTMLInputElement>): void {
    if (mask) {
      const maskedValue = mask(e.target.value);
      e.target.value = maskedValue;
    }
    register.onChange(e);
  }

  return (
    <div className="flex flex-col gap-1 text-lg md:text-xl">
      <label className="font-medium">{label}</label>
      <input
        type="text"
        className={inputClassName}
        autoComplete="off"
        {...register}
        onChange={handleChange}
      />
      {error && <span className="text-red-500 text-sm">{error}</span>}
    </div>
  );
}
