import { weekDayEnum } from "../enums/date/week";

export type CompanyOpeningHourModel = {
  weekDay: weekDayEnum;
  range: {
    init: string;
    end: string;
  };
};