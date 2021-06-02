declare global {
  module '@sapper/server' {
    // eslint-disable-next-line no-unused-vars
    interface SapperRequest {
      communityId: string;
      locale: string;
      communityId: number;
      userId: number;
      isAuthenticated: boolean;
      apiUrl: string;
    }
  }
}
