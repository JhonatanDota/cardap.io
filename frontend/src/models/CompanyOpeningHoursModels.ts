import { weekDayEnum } from "../enums/date/week";

export type CompanyOpeningHourModel = {
  weekDay: weekDayEnum;
  openHour: string;
  closeHour: string;
};
