import { UseFormRegisterReturn } from "react-hook-form";

interface SelectInputProps {
  label: string;
  options: string[];
  error?: string;
  register: UseFormRegisterReturn;
}

export default function SelectInput(props: SelectInputProps) {
  const { label, options, error, register } = props;

  return (
    <div className="flex flex-col gap-1 text-lg md:text-xl">
      <label className="font-normal">{label}</label>
      <select
        className="border-[2px] border-gray-200 font-medium bg-white p-[0.600rem] shadow-sm rounded-sm focus:outline-none"
        {...register}
      >
        {options.map((option) => (
          <option key={option} value={option}>
            {option}
          </option>
        ))}
      </select>
      {error && <span className="text-red-500 text-sm">{error}</span>}
    </div>
  );
}
