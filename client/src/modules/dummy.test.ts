import { dummy } from './dummy';

describe('dummy', () => {
  it('should return a string', () => {
    expect(dummy()).toBe('hello world');
  });
});
