import { OpeningHoursModel } from "../models/openingHoursModels";
import { weekDayEnum } from "../enums/date/week";

export const OPENING_HOURS_1: OpeningHoursModel = [
  {
    weekDay: weekDayEnum.MONDAY,
    range: {
      init: "10:00",
      end: "15:00",
    },
  },

  {
    weekDay: weekDayEnum.TUESDAY,
    range: {
      init: "10:00",
      end: "15:00",
    },
  },

  {
    weekDay: weekDayEnum.WEDNESDAY,
    range: {
      init: "10:00",
      end: "15:00",
    },
  },

  {
    weekDay: weekDayEnum.THURSDAY,
    range: {
      init: "10:00",
      end: "15:00",
    },
  },

  {
    weekDay: weekDayEnum.FRIDAY,
    range: {
      init: "10:00",
      end: "15:00",
    },
  },
];
