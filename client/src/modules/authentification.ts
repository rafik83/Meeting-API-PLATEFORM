export const authentificationMiddleWare = () => {
  return (req, res, next) => {
    if (
      req.url.startsWith('/client') ||
      req.url.startsWith('/service-worker')
    ) {
      next();
    }

    if (Object.keys(req.cookies).length > 0 && req.cookies['userId']) {
      req.userId = req.cookies['userId'];
    }
    next();
  };
};
