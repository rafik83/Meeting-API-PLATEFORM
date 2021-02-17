export const communityMiddleWare = () => {
  return (req, res, next) => {
    /**
     * THIS IS TEMPORARY
     * SHOULD BE IMPLEMENTED TO GET COMMUNITY ID FORM THE URL
     */
    req.communityId = 1;
    next();
  };
};
