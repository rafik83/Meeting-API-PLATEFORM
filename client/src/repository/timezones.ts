import type { TimeZone } from '../domain';
import { get } from '../modules/axios';

export const getTimeZones = async (): Promise<Array<TimeZone>> =>
  (await get<Array<TimeZone>>('/timezones')).data;
