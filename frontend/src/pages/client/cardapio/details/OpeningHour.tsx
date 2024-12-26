import { OpeningHoursModel } from "../../../../models/openingHoursModels";
import { weekDayAcronymReadableEnum } from "../../../../enums/date/week";

interface OpeningHourProps {
  openingHours: OpeningHoursModel;
}

export default function OpeningHour(props: OpeningHourProps) {
  const { openingHours } = props;

  return (
    <div className="flex flex-col items-center gap-3">
      <h3 className="uppercase text-base font-medium">Horários</h3>

      <div className="flex flex-col w-full">
        {openingHours.map((openingHour, index) => (
          <div
            className="grid grid-cols-2 justify-items-center gap-1 text-sm"
            key={index}
          >
            <span className="uppercase font-bold">
              {weekDayAcronymReadableEnum[openingHour.weekDay]}
            </span>

            <span>
              {openingHour.range.init} - {openingHour.range.end}
            </span>

            <hr className="col-span-2 h-2 w-full" />
          </div>
        ))}
      </div>
    </div>
  );
}
