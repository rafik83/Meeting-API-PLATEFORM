export const flagsUnicode = { fr: '🇫🇷', en: '🇬🇧' };

export const getFlagIconFromIsoCode = (isoCode: string): string | null => {
  const code = flagsUnicode[isoCode];
  if (!code) {
    return null;
  }
  return code;
};
