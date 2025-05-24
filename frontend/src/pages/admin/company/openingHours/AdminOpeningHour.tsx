import {
  UseFormRegisterReturn,
  useWatch,
  useFormContext,
} from "react-hook-form";

import { CompanyOpeningHourModel } from "../../../../models/CompanyOpeningHoursModels";

import { weekDayReadableEnum } from "../../../../enums/date/week";

import { CiLock, CiUnlock } from "react-icons/ci";

type AdminOpeningHourProps = {
  openingHour: CompanyOpeningHourModel;
  registerInit: UseFormRegisterReturn;
  registerEnd: UseFormRegisterReturn;
  errors: {
    range?: { message?: string };
    init?: { message?: string };
    end?: { message?: string };
  };
};

export default function AdminOpeningHour(props: AdminOpeningHourProps) {
  const { openingHour, registerInit, registerEnd, errors } = props;

  const { control } = useFormContext();

  const initValue = useWatch({ control, name: registerInit.name });
  const endValue = useWatch({ control, name: registerEnd.name });

  function isDayClosed(initHour: string, endHour: string): boolean {
    return initHour === "00:00" && endHour === "00:00";
  }

  return (
    <div className="grid grid-cols-1 items-center border-2 gap-2 border-gray-200 rounded-md p-2">
      <div className="flex flex-col items-center">
        <span className="text-base md:text-lg font-bold">
          {weekDayReadableEnum[openingHour.weekDay].toUpperCase()}
        </span>
        <span
          className={`text-sm md:text-base font-medium ${
            isDayClosed(initValue, endValue) ? "text-red-500" : "text-green-600"
          }`}
        >
          {isDayClosed(initValue, endValue) ? "Fechado" : "Aberto"}
        </span>
      </div>

      <div className="flex flex-col gap-2">
        <div className="flex flex-col">
          <div className="flex items-center gap-2">
            <CiLock className="w-6 h-6 fill-green-600" />

            <input
              className="w-full font-medium p-1.5 border-2 focus:outline-none"
              type="time"
              autoComplete="off"
              {...registerInit}
            />
          </div>
          {errors.init && (
            <span className="text-red-500 text-sm">{errors.init.message}</span>
          )}
        </div>

        <div className="flex flex-col">
          <div className="flex items-center gap-2">
            <CiUnlock className="w-6 h-6 fill-red-500" />

            <input
              className="w-full font-medium p-1.5 border-2 focus:outline-none"
              type="time"
              autoComplete="off"
              {...registerEnd}
            />
          </div>

          {errors.end && (
            <span className="text-red-500 text-sm">{errors.end.message}</span>
          )}
        </div>

        {errors.range && (
          <span className="text-red-500 text-sm">{errors.range.message}</span>
        )}
      </div>
    </div>
  );
}
