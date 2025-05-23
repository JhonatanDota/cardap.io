import { weekDayEnum } from "../../enums/date/week";
import { CompanyOpeningHourModel } from "../../models/CompanyOpeningHoursModels";

export const openingHoursConstants: CompanyOpeningHourModel[] = [
  {
    weekDay: weekDayEnum.MONDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
  {
    weekDay: weekDayEnum.TUESDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
  {
    weekDay: weekDayEnum.WEDNESDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
  {
    weekDay: weekDayEnum.THURSDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
  {
    weekDay: weekDayEnum.FRIDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
  {
    weekDay: weekDayEnum.SATURDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
  {
    weekDay: weekDayEnum.SUNDAY,
    range: {
      init: "00:00",
      end: "00:00",
    },
  },
];
