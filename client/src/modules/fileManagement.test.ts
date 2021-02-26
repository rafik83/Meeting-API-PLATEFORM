import { buildFakeFile, buildFakeFileList } from '../__fixtures__/FakeFileList';
import { getFileUploadReport } from './fileManagement';
import type { ErrorReport } from './fileManagement';

describe('fileManagement', () => {
  describe('validateFiles', () => {
    it('should return no errors if all files have the right size and type   ', () => {
      const fileName1 = 'toto.jpeg';
      const fileName2 = 'tata.jpeg';

      const filesize = 1048576;

      const fakeFile1 = buildFakeFile(fileName1, 'image/jpeg', filesize);
      const fakeFile2 = buildFakeFile(fileName2, 'image/jpeg', filesize);

      const fakeFileList = buildFakeFileList([fakeFile1, fakeFile2]);

      const expectedResult = [
        {
          fileName: fileName1,
          hasErrors: false,
          errors: {
            maxSizeExceeded: false,
            wrongMimeType: false,
          },
        },
        {
          fileName: fileName2,
          hasErrors: false,
          errors: {
            maxSizeExceeded: false,
            wrongMimeType: false,
          },
        },
      ];

      const acceptedMimeTypes = ['image/png', 'image/jpeg'];
      const maxSize = 1024 * 1024;

      const validate = getFileUploadReport(
        fakeFileList,
        acceptedMimeTypes,
        maxSize
      );
      expect(validate).toStrictEqual(expectedResult);
    });

    it('should return errors if a file has no expected mime type', () => {
      const fileName1 = 'toto.jpeg';
      const fileName2 = 'tata.jpeg';

      const filesize = 1024;

      const fakeFile1 = buildFakeFile(fileName1, 'image/jpeg', filesize);
      const fakeFile2 = buildFakeFile(fileName2, 'image/toto', filesize);

      const fakeFileList = buildFakeFileList([fakeFile1, fakeFile2]);

      const expectedResult = [
        {
          fileName: fileName1,
          hasErrors: false,
          errors: {
            maxSizeExceeded: false,
            wrongMimeType: false,
          },
        },

        {
          fileName: fileName2,
          hasErrors: true,
          errors: {
            wrongMimeType: true,
            maxSizeExceeded: false,
          },
        },
      ];

      const acceptedMimeTypes = ['image/png', 'image/jpeg'];
      const maxSize = 1024 * 1024;

      expect(
        getFileUploadReport(fakeFileList, acceptedMimeTypes, maxSize)
      ).toStrictEqual(expectedResult);
    });

    it('should return errors if a file exceed the expected file size ', () => {
      const fileName1 = 'toto.jpeg';
      const fileName2 = 'tata.jpeg';

      const fakeFile1 = buildFakeFile(fileName1, 'image/jpeg', 300);
      const fakeFile2 = buildFakeFile(fileName2, 'image/jpeg', 500);

      const fakeFileList = buildFakeFileList([fakeFile1, fakeFile2]);

      const expectedResult = [
        {
          fileName: fileName1,
          hasErrors: false,
          errors: {
            maxSizeExceeded: false,
            wrongMimeType: false,
          },
        },

        {
          fileName: fileName2,
          hasErrors: true,
          errors: {
            maxSizeExceeded: true,
            wrongMimeType: false,
          },
        },
      ];

      const acceptedMimeTypes = ['image/png', 'image/jpeg'];
      const maxSize = 300;

      expect(
        getFileUploadReport(fakeFileList, acceptedMimeTypes, maxSize)
      ).toStrictEqual(expectedResult);
    });

    it('should return errors if a file exceed the expected file size and has a wrong mimeType ', () => {
      const fileName1 = 'toto.jpeg';
      const fileName2 = 'tata.jpeg';
      const fileName3 = 'tututo.jpeg';

      const filesize = 1024;

      const fakeFile1 = buildFakeFile(fileName1, 'image/toto', filesize);
      const fakeFile2 = buildFakeFile(fileName2, 'image/jpeg', 2 * 1024 * 1024);
      const fakeFile3 = buildFakeFile(fileName3, 'image/toto', 2 * 1024 * 1024);

      const fakeFileList = buildFakeFileList([fakeFile1, fakeFile2, fakeFile3]);

      const expectedResult: Array<ErrorReport> = [
        {
          fileName: fileName1,
          hasErrors: true,
          errors: {
            maxSizeExceeded: false,
            wrongMimeType: true,
          },
        },

        {
          fileName: fileName2,
          hasErrors: true,
          errors: {
            maxSizeExceeded: true,
            wrongMimeType: false,
          },
        },

        {
          fileName: fileName3,
          hasErrors: true,
          errors: {
            maxSizeExceeded: true,
            wrongMimeType: true,
          },
        },
      ];

      const acceptedMimeTypes = ['image/png', 'image/jpeg'];
      const maxSize = 1024 * 1024;

      const result = getFileUploadReport(
        fakeFileList,
        acceptedMimeTypes,
        maxSize
      );

      expect(result).toStrictEqual(expectedResult);
    });
  });
});
