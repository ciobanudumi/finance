import React from 'react';

export interface AppRoutes {
  path: string;
  name: string;
  component: (
    props:
      | React.ComponentProps<(props) => React.JSX.Element>
      | React.ComponentProps<({ children }: { children?: any }) => React.JSX.Element>
      | React.ComponentProps<() => React.JSX.Element>,
  ) => React.JSX.Element;
  routes?: AppRoutes[] | null;
}
