import React from 'react';
import classnames from 'classnames';
import WorkflowIcon from './WorkflowIcon';
import { Button } from 'reactstrap';

export default ({ loading, children }) => {
  const iconClasses = classnames({
    'trello-workflow__icon': true,
    'btn--loading': loading
  });

  return (
    <Button id="TrelloWorkflow" className="trello-workflow__indicator">
      <div className={iconClasses}>
        {loading ? null : <WorkflowIcon />}
      </div>
      {loading ? null : children}
    </Button>
  );
};
