export const generateRoute = route => {
  const urlParts = route.split('?');
  let params = new URLSearchParams(urlParts[1] || '');

  return `${urlParts[0]}?${params.toString()}`;
};
