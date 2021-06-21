import React from 'react';
import MUIAppBar, { AppBarProps } from '@material-ui/core/AppBar';
import Toolbar from '@material-ui/core/Toolbar';
import IconButton from '@material-ui/core/IconButton';
import MenuIcon from '@material-ui/icons/Menu';
import { makeStyles } from '@material-ui/styles';
import Container from '@material-ui/core/Container';
import { RightArrow } from '../Icons';
import { Link, Typography } from '@material-ui/core';
import { RouteLink } from '../link';

const useStyles = makeStyles(() => ({
  root: {
    flexGrow: 1,
  },
  logo: {
    flexGrow: 1,
    color: '#fff',
  },
  logoImage: {
    maxWidth: '131px',
    width: '100%',
  },
  toolbar: {
    paddingLeft: 0,
    paddingRight: 0,
  },
}));

export type Props = {
  onClickBack?: () => void;
} & AppBarProps;

export const PrimaryAppBar = function ({
  onClickBack,
  children,
  ...props
}: Props) {
  const classes = useStyles();
  return (
    <div className={classes.root}>
      <MUIAppBar position="static" {...props}>
        <Container maxWidth="lg">
          <Toolbar className={classes.toolbar}>
            {onClickBack ? <RightArrow /> : null}
            <Link className={classes.logo} component={RouteLink} href="/">
              <Typography variant="h6" color="inherit" noWrap>
                Root App
              </Typography>
            </Link>
            {children}
            <IconButton edge="end" color="inherit" aria-label="menu">
              <MenuIcon />
            </IconButton>
          </Toolbar>
        </Container>
      </MUIAppBar>
    </div>
  );
};
