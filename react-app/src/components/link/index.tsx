import React from 'react';
import { Link } from 'react-router-dom';

type RouteLinkWithHref = Omit<React.ComponentProps<Link>, 'to'> &
  Pick<HTMLAnchorElement, 'href'>;

export const RouteLink = ({ href, ...props }: RouteLinkWithHref) => (
  <Link to={href} {...props} />
);

export const RouteLinkWithRef = React.forwardRef(
  (
    { href, ...props }: RouteLinkWithHref,
    ref: React.Ref<HTMLAnchorElement>,
  ) => <Link ref={ref} to={href} {...props} />,
);

RouteLinkWithRef.displayName = 'RouteLinkWithRef';
