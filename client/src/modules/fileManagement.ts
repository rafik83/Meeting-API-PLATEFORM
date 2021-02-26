export type ErrorReport = {
  fileName: string;
  hasErrors: boolean;
  errors: {
    [key: string]: boolean;
  };
};

const hasValidMimeType = (file: File, mimeTypes: Array<string>): boolean =>
  mimeTypes.findIndex((type) => type == file.type) !== -1;

const doesNotExceedMaxSize = (file: File, maxSize: number): boolean => {
  return file.size <= maxSize;
};

export const getFileUploadReport = (
  fileList: FileList,
  acceptedMimeType: Array<string>,
  maxSize: number
): Array<ErrorReport> => {
  const keys = Object.keys(fileList);
  const filteredKeys = keys.filter((item) => {
    return !isNaN(parseInt(item));
  });

  return filteredKeys.map(
    (item): ErrorReport => {
      const isValidMimeType = hasValidMimeType(
        fileList[item],
        acceptedMimeType
      );
      const isNotExceedMaxSize = doesNotExceedMaxSize(fileList[item], maxSize);
      return {
        fileName: fileList[item].name,
        hasErrors: !isValidMimeType || !isNotExceedMaxSize, // mettre ce booléan à true si hasValidMimeType() retourne true OU si doesNotExceedMaxSize retourne true
        errors: {
          wrongMimeType: !isValidMimeType,
          maxSizeExceeded: !isNotExceedMaxSize,
        },
      };
    }
  );
};
