import { z } from "zod";

import { weekDayEnum } from "../../../../../enums/date/week";

export const syncOpeningHoursSchemaData = z.object({
  openingHours: z.array(
    z.object({
      weekDay: z.nativeEnum(weekDayEnum),
      range: z.object({
        init: z.string().nonempty(),
        end: z.string().nonempty(),
      }),
    })
  ),
});

export type SyncOpeningHoursSchemaType = z.infer<
  typeof syncOpeningHoursSchemaData
>;
