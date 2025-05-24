import { weekDayEnum } from "../../enums/date/week";
import { CompanyOpeningHourModel } from "../../models/CompanyOpeningHoursModels";

export const openingHoursConstants: CompanyOpeningHourModel[] = [
  {
    weekDay: weekDayEnum.MONDAY,
    openHour: "00:00",
    closeHour: "00:00",
  },
  {
    weekDay: weekDayEnum.TUESDAY,
    openHour: "00:00",
    closeHour: "00:00",
  },
  {
    weekDay: weekDayEnum.WEDNESDAY,
    openHour: "00:00",
    closeHour: "00:00",
  },
  {
    weekDay: weekDayEnum.THURSDAY,
    openHour: "00:00",
    closeHour: "00:00",
  },
  {
    weekDay: weekDayEnum.FRIDAY,

    openHour: "00:00",
    closeHour: "00:00",
  },
  {
    weekDay: weekDayEnum.SATURDAY,

    openHour: "00:00",
    closeHour: "00:00",
  },
  {
    weekDay: weekDayEnum.SUNDAY,

    openHour: "00:00",
    closeHour: "00:00",
  },
];
