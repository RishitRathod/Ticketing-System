import DatePicker from "react-multi-date-picker"
import { Calendar } from "react-multi-date-picker"
import { DateObject } from "react-multi-date-picker"
import React, { useState } from 'react';
import ReactDOM from 'react-dom';

const App = () => {
  const [values, setValues] = useState([
    [new DateObject().set({ day: 1 }), new DateObject().set({ day: 3 })],
    [new DateObject().set({ day: 6 }), new DateObject().set({ day: 12 })],
    [new DateObject().set({ day: 23 }), new DateObject().set({ day: 27 })],
  ]);

  return (
    <Calendar
      value={values}
      onChange={setValues}
      multiple
      range
    />
  );
};

ReactDOM.render(<App />, document.getElementById('app'));
