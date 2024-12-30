import { useState } from "react";

interface TextInputProps {
  label: string;
  initialValue?: string;
  mask?: string;
}

export default function TextInput(props: TextInputProps) {
  const { label, initialValue } = props;

  const [value, setValue] = useState(initialValue);

  return (
    <div className="flex flex-col gap-1 text-sm">
      <label className="font-medium">{label}</label>

      <input
        className="border-2 border-gray-900 px-2 py-1 rounded-md shadow-sm transition-colors duration-100 focus:border-purple-800 focus:outline-none"
        type="text"
        value={value}
        onChange={(e) => setValue(e.target.value)}
      />
    </div>
  );
}
