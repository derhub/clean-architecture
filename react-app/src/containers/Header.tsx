import {
  AppBar,
  Button,
  Link,
  makeStyles,
  Toolbar,
  Typography,
} from '@material-ui/core';
import React from 'react';

import { PrimaryAppBar } from '../components/AppBar';
import { RouteLinkWithRef } from '../components/link';

const useStyles = makeStyles((theme) => ({
  '@global': {
    ul: {
      margin: 0,
      padding: 0,
      listStyle: 'none',
    },
  },
  appBar: {
    borderBottom: `1px solid ${theme.palette.divider}`,
  },
  toolbar: {
    flexWrap: 'wrap',
  },
  toolbarTitle: {
    flexGrow: 1,
  },
  link: {
    margin: theme.spacing(1, 1.5),
  },
  heroContent: {
    padding: theme.spacing(8, 0, 6),
  },
  cardHeader: {
    backgroundColor:
      theme.palette.type === 'light'
        ? theme.palette.grey[200]
        : theme.palette.grey[700],
  },
  cardPricing: {
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'baseline',
    marginBottom: theme.spacing(2),
  },
  footer: {
    borderTop: `1px solid ${theme.palette.divider}`,
    marginTop: theme.spacing(8),
    paddingTop: theme.spacing(3),
    paddingBottom: theme.spacing(3),
    [theme.breakpoints.up('sm')]: {
      paddingTop: theme.spacing(6),
      paddingBottom: theme.spacing(6),
    },
  },
}));

export const Header = (props: React.ComponentProps<typeof AppBar>) => {
  const classes = useStyles();
  return (
    <>
      <PrimaryAppBar
        position="static"
        color="primary"
        elevation={0}
        className={classes.appBar}
        {...props}>
        <Toolbar className={classes.toolbar}>
          <nav>
            <Link
              href="/"
              variant="button"
              color="textSecondary"
              className={classes.link}>
              Features
            </Link>
            <Link
              variant="button"
              color="textSecondary"
              href="/"
              className={classes.link}>
              Enterprise
            </Link>
            <Link
              variant="button"
              color="textSecondary"
              href="/"
              className={classes.link}>
              Support
            </Link>
          </nav>
          <Button
            component={RouteLinkWithRef}
            href="/login"
            color="secondary"
            variant="contained"
            className={classes.link}>
            Login
          </Button>
        </Toolbar>
      </PrimaryAppBar>
    </>
  );
};
