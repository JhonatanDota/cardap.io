import { UseFormRegisterReturn } from "react-hook-form";

import { CompanyOpeningHourModel } from "../../../../models/CompanyOpeningHoursModels";

import { weekDayReadableEnum } from "../../../../enums/date/week";

import { timeMask } from "../../../../utils/input/masks";

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

  function handleChangeInit(e: React.ChangeEvent<HTMLInputElement>): void {
    e.target.value = timeMask(e.target.value);
    registerInit.onChange(e);
  }

  function handleChangeEnd(e: React.ChangeEvent<HTMLInputElement>): void {
    e.target.value = timeMask(e.target.value);
    registerEnd.onChange(e);
  }

  return (
    <div className="grid grid-cols-3 items-center border-2 gap-2 border-gray-200 rounded-md p-2">
      <span className="text-base text-center font-bold col-span-2">
        {weekDayReadableEnum[openingHour.weekDay].toUpperCase()}
      </span>

      <div className="flex flex-col gap-2">
        <div className="flex flex-col">
          <input
            className="p-1.5 border-2 focus:outline-none"
            type="text"
            autoComplete="off"
            {...registerInit}
            onChange={handleChangeInit}
          />
          {errors.init && (
            <span className="text-red-500 text-sm">{errors.init.message}</span>
          )}
        </div>

        <div className="flex flex-col">
          <input
            className="p-1.5 border-2 focus:outline-none"
            type="text"
            autoComplete="off"
            {...registerEnd}
            onChange={handleChangeEnd}
          />
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
