import Icon, { IconProps } from '@material-ui/core/Icon';
import clsx from 'clsx';
import React from 'react';

export function Burger({ className, ...props }: IconProps) {
  return <Icon className={clsx(className, 'eb eb-burger')} {...props} />;
}

export function RightArrow({ className, ...props }: IconProps) {
  return <Icon className={clsx(className, 'eb eb-pr')} {...props} />;
}
