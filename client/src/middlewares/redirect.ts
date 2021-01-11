export const redirectToLocalePage = () => {
  return (req, res, next) => {
    let url = `/` + req.locale;
    let str = `Redirecting to ${url}`;

    if (req.path === '/') {
      res.writeHead(302, {
        Location: url,
        'Content-Type': 'text/plain',
        'Content-Length': str.length,
      });

      res.end(str);
      return;
    }

    next();
  };
}
