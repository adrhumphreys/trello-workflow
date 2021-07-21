import React, { useState } from 'react';
import WorkflowIndicator from './WorkflowIndicator';
import { WorkflowSelector } from './WorkflowSelector';
import LargeMenu from './Menus/Large';
import SmallMenu from './Menus/Small';

export default ({
  cardId,
  small,
  states,
  currentStateId,
  workflowEndpoint,
  noneSelected,
  viewOnTrelloText
}) => {
  const [loading, setLoading] = useState(false);
  const [currentState, setCurrentState] = useState(states.find(({ id }) => id === currentStateId));
  const [isSelectorOpen, setSelectorOpen] = useState(false);
  const toggleSelector = () => setSelectorOpen(!isSelectorOpen);

  const onWorkflowSelected = (stepId) => {
    const switchingFrom = currentState;
    setCurrentState(states.find(({ id }) => id === stepId));
    setLoading(true);

    fetch(workflowEndpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json'
      },
      body: JSON.stringify({
        cardId,
        stepId
      })
    }).then((response) => {
      // success is pre-emptive, so only reset if there was a problem (e.g. 500)
      if (response.status !== 200) {
        setCurrentState(switchingFrom);
      }
    }).finally(() => setLoading(false));
  };

  return (
    <div className="trello-workflow__widget">
      <WorkflowIndicator loading={loading} onClick={toggleSelector}>
        {small ? null : (<p>{currentState.title || noneSelected}</p>)}
      </WorkflowIndicator>
      <WorkflowSelector
        options={states || []}
        selected={currentState}
        setActiveWorkflow={onWorkflowSelected}
        MenuComponent={small ? SmallMenu : LargeMenu}
        viewOnTrelloText={viewOnTrelloText}
        isOpen={isSelectorOpen}
        toggle={toggleSelector}
      />
    </div>
  );
};
