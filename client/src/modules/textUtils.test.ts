import { capitalize } from './textUtils';

describe('templateUtils', () => {
  describe('capitalize', () => {
    it('should capitalize one letter', () => {
      const expectedResult = 'T';
      const result = capitalize('t');
      expect(result).toStrictEqual(expectedResult);
    });
    it('should capitalize one word', () => {
      const expectedResult = 'Hello';
      const result = capitalize('hello');
      expect(result).toStrictEqual(expectedResult);
    });
    it('should capitalize each words of sentence', () => {
      const expectedResult = 'Hello World Of Letters';
      const result = capitalize('hello world of letters');
      expect(result).toStrictEqual(expectedResult);
    });
  });
});
