export const flatRoutes = routes => {
  const renderRoutes = (arrayRoutes, flattenRoutes = [{}], url = '') => {
    if (!arrayRoutes) {
      return null;
    }
    url = url === '/' ? '' : url; // ignore "/" root url so we can use "/<path" further down the nested routes

    arrayRoutes.forEach(route => {
      const { name, path, routes: childRoutes } = route;
      if (name) {
        const breadRoute = {
          path: `${url}${path}`,
          name: name,
        };
        flattenRoutes.push(breadRoute);
      }

      if (childRoutes) {
        return renderRoutes(childRoutes, flattenRoutes, `${url}${path}`);
      }
    });

    return flattenRoutes;
  };

  return renderRoutes(routes);
};

export default flatRoutes;
