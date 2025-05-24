import { z } from "zod";
import { weekDayEnum } from "../../../../../enums/date/week";

const CompanyOpeningHourSchema = z.object({
  weekDay: z.nativeEnum(weekDayEnum),
  openHour: z.string(),
  closeHour: z.string(),
});

export const syncOpeningHoursSchemaData = z.object({
  openingHours: z.array(CompanyOpeningHourSchema),
});

export type SyncOpeningHoursSchemaType = z.infer<
  typeof syncOpeningHoursSchemaData
>;
