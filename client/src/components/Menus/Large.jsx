import React from 'react';
import { Dropdown, DropdownMenu, DropdownToggle } from 'reactstrap';

export default ({ isOpen, toggle, children }) => (
  <Dropdown isOpen={isOpen} toggle={toggle}>
    <DropdownToggle>
      choose
    </DropdownToggle>
    <DropdownMenu>
      {children}
    </DropdownMenu>
  </Dropdown>
);
