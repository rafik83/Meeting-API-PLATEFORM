import { getDomainFromEmail } from './email';

describe('email', () => {
  describe('getDomainFromEmail', () => {
    it('should return an domain from email', () => {
      const totoemail = 'toto@evilcorp.com';
      expect(getDomainFromEmail(totoemail)).toBe('evilcorp.com');
    });
  });
});
