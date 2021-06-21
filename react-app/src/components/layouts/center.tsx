import { Box, makeStyles } from '@material-ui/core';
import clsx from 'clsx';
import React, { ComponentProps } from 'react';

const useStyles = makeStyles({
  box: {
    height: '100%',
  },
});

export function CenterBoxLayout({
  children,
  className,
  ...props
}: ComponentProps<typeof Box>) {
  const classes = useStyles();

  return (
    <Box
      display="flex"
      justifyContent="center"
      alignItems="center"
      {...props}
      className={clsx(classes.box, className)}>
      {children}
    </Box>
  );
}
