import React from 'react';
import ReactDOM from 'react-dom';

import { App } from './App';

if (typeof window !== 'undefined') {
  import('./pwa');
}

ReactDOM.render(<App />, document.getElementById('root'));
