export const buildFakeFile = (
  fileName: string,
  type: string,
  size: number
): File => {
  return new File([new ArrayBuffer(size)], fileName, {
    type,
  });
};

export const buildFakeFileList = (fakeFiles?: Array<File>): FileList => {
  if (fakeFiles && fakeFiles.length > 0) {
    const workingFakeFiles = fakeFiles.reduce((previous, current, index) => {
      return {
        ...previous,
        [index]: current,
      };
    }, {});
    return {
      length: 1024,
      item: () => fakeFiles[0],
      ...workingFakeFiles,
    };
  }

  return {
    length: 1024,
    item: () => fakeFiles[0],
    0: buildFakeFile('toto', 'image/hello', 66666666666),
  };
};
