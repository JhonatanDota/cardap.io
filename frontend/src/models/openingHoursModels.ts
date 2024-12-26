import { weekDayEnum } from "../enums/date/week";

export type OpeningHourModel = {
  weekDay: weekDayEnum;
  range: {
    init: string;
    end: string;
  };
};

export type OpeningHoursModel = OpeningHourModel[];
