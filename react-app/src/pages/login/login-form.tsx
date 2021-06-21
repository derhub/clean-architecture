import {
  Button,
  Checkbox,
  FormControlLabel,
  Grid,
  Link,
  makeStyles,
  TextField,
  Typography,
} from '@material-ui/core';
import React from 'react';

const useStyles = makeStyles((theme) => ({
  paper: {
    margin: theme.spacing(3),
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    maxWidth: '400px',
  },
  avatar: {
    // margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main,
  },
  form: {
    width: '100%', // Fix IE 11 issue.
    marginTop: theme.spacing(1),
  },
  submit: {
    margin: theme.spacing(3, 0, 2),
  },
}));

export const LoginForm = () => {
  const classes = useStyles();
  return (
    <div className={classes.paper}>
      <Typography component="h1" variant="h5">
        Sign in
      </Typography>
      <form className={classes.form} noValidate>
        <TextField
          variant="outlined"
          margin="normal"
          required
          fullWidth
          id="email"
          placeholder="Email Address"
          name="email"
          autoComplete="email"
        />
        <TextField
          variant="outlined"
          margin="normal"
          required
          fullWidth
          name="password"
          placeholder="Password"
          type="password"
          id="password"
          autoComplete="current-password"
        />
        <FormControlLabel
          control={<Checkbox value="remember" color="primary" />}
          label="Remember me"
        />
        <Button
          type="submit"
          fullWidth
          variant="contained"
          color="primary"
          disableElevation
          className={classes.submit}>
          Sign In
        </Button>
        <Grid container>
          <Grid item xs>
            <Link href="/" variant="body2">
              Forgot password?
            </Link>
          </Grid>
          <Grid item>
            <Link href="/" variant="body2">
              {"Don't have an account? Sign Up"}
            </Link>
          </Grid>
        </Grid>
      </form>
    </div>
  );
};
