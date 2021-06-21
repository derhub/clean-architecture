import { Link, Typography } from '@material-ui/core';
import { RouteLink } from 'components/link';
import React from 'react';

export function Copyright() {
  return (
    <Typography variant="body2" color="textSecondary" align="center">
      {'Copyright © '}
      <Link
        component={RouteLink}
        color="inherit"
        href="https://material-ui.com/">
        Your Website
      </Link>{' '}
      {new Date().getFullYear()}
      {'.'}
    </Typography>
  );
}
