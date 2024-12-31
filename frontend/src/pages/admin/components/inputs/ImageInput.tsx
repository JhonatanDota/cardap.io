import { useState } from "react";

interface ImageInputProps {
  label: string;
  initialImageUrl: string | null;
}

export default function ImageInput(props: ImageInputProps) {
  const { label, initialImageUrl } = props;

  const [preview, setPreview] = useState<string | null>(initialImageUrl);

  function handleImageChange(e: React.ChangeEvent<HTMLInputElement>) {
    const file = e.target.files?.[0] || null;

    if (file) {
      const previewUrl = URL.createObjectURL(file);
      setPreview(previewUrl);
    } else {
      setPreview(null);
    }
  }

  function handleRemoveImage() {
    setPreview(null);
  }

  return (
    <div className="flex flex-col gap-2 text-base">
      <label className="font-medium">{label}</label>

      <div className="flex flex-col items-center gap-2">
        {preview ? (
          <div className="relative grow h-40">
            <img
              src={preview}
              alt={label}
              className="w-full h-full object-cover rounded-md shadow-md"
            />
            <button
              type="button"
              onClick={handleRemoveImage}
              className="absolute top-0 right-0 bg-red-500 text-white font-bold rounded-md p-1"
            >
              ✕
            </button>
          </div>
        ) : (
          <div className="w-full h-40 flex items-center justify-center bg-gray-100 border-2 border-dashed border-gray-300 rounded-md">
            Nenhuma imagem
          </div>
        )}

        <label className="w-full text-sm text-center font-bold bg-blue-700 text-white px-4 py-2 rounded-md shadow cursor-pointer">
          Escolher {label}
          <input
            type="file"
            accept="image/*"
            className="hidden"
            onChange={handleImageChange}
          />
        </label>
      </div>
    </div>
  );
}
