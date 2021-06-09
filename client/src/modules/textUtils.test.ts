import { capitalize, ellipse, slugify } from './textUtils';

describe('textUtils', () => {
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

  describe('slugify', () => {
    it('should slugify a sentence', () => {
      const expectedResult = 'my-generation';
      const result = slugify('my generation ');
      expect(result).toStrictEqual(expectedResult);
    });

    it('should slugify a sentence and replace spacial chars', () => {
      const expectedResult = 'my-generation-dollar';
      const result = slugify('my generation $');
      expect(result).toStrictEqual(expectedResult);
    });

    it('should slugify a sentence and remove spacial chars', () => {
      const expectedResult = 'my-generation';
      const result = slugify('my gener``ation');
      expect(result).toStrictEqual(expectedResult);
    });
  });

  describe('ellipse', () => {
    it('should ellipse a long text', () => {
      const expectedResult = 'a very [...]';
      const result = ellipse('a very long text', 7);
      expect(result).toStrictEqual(expectedResult);
    });
  });
});
