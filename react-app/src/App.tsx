import React, { useState } from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';

import { FullPageLoadingIndicator } from './components/loading-indicators';
import { lazyLoad } from './utils';
import {
  createMuiTheme,
  ThemeOptions,
  ThemeProvider,
} from '@material-ui/core/styles';
import CssBaseline from '@material-ui/core/CssBaseline';
import { PaletteOptions } from '@material-ui/core/styles/createPalette';

const HomePage = lazyLoad(() => import('./pages/home'), {
  fallback: <FullPageLoadingIndicator />,
  resolveComponent: (comps) => comps.HomePage,
});

const LoginPage = lazyLoad(() => import('./pages/login'), {
  fallback: <FullPageLoadingIndicator />,
  resolveComponent: (comps) => comps.LoginPage,
});

export function AppRoutes() {
  return (
    <Switch>
      <Route exact={true} path="/">
        <HomePage />
      </Route>
      <Route path="/login">
        <LoginPage />
      </Route>
    </Switch>
  );
}

const defaultValues = {
  radius: 10,
};

const themeLight: ThemeOptions = {
  typography: {
    fontSize: 16,
  },
  overrides: {
    MuiButton: {
      root: {
        borderRadius: defaultValues.radius,
      },
      label: {
        textSpacing: '1px',
      },
      outlined: {
        borderWidth: 2,
      },
      contained: {
        boxShadow: 'none',
        '&:hover': {
          boxShadow: 'none',
        },
      },
    },
  },
};

const themeDark: ThemeOptions = {
  ...themeLight,
  palette: {
    ...themeLight.palette,
    type: 'dark',
  },
};

const activeTheme = (isDark: boolean) => (isDark ? themeDark : themeLight);

export function App() {
  // const prefersDarkMode = useMediaQuery('(prefers-color-scheme: dark)');
  const [darkMode] = useState(
    // prefersDarkMode,
    false,
  );

  const theme = React.useMemo(
    () => createMuiTheme(activeTheme(darkMode)),
    [darkMode],
  );
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <Router>
        <AppRoutes />
      </Router>
    </ThemeProvider>
  );
}
