import { PaymentMethodConstantType } from "../../../../constants/payment/paymentMethodsConstants";

import { UseFormRegisterReturn } from "react-hook-form";

interface PaymentMethodCardProps {
  paymentMethod: PaymentMethodConstantType;
  register: UseFormRegisterReturn;
}

export default function AdminPaymentMethodCard(props: PaymentMethodCardProps) {
  const { paymentMethod, register } = props;

  return (
    <div className="relative flex justify-center border-2 border-gray-200 p-3 md:p-6 rounded-md">
      <div className="flex flex-col items-center">
        <span className="text-base font-medium">{paymentMethod.name}</span>
        <div className="w-12 h-12">{paymentMethod.icon}</div>
      </div>

      <input
        className="absolute right-5 top-1/2 -translate-y-1/2 w-8 h-8 cursor-pointer checked:bg-green-500"
        type="checkbox"
        {...register}
      />
    </div>
  );
}
