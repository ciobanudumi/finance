import React, { useEffect, useState } from 'react';
import { CMultiSelect } from '@coreui/react-pro';
import { Option } from '@coreui/react-pro/dist/components/multi-select/types';
import { useDispatch, useSelector } from 'react-redux';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { reducer, sliceKey, userSelectActions } from './slice';
import { userSelectSaga } from './saga';
import { selectUsersData } from './selectors';
import { User } from '../../../types/User';

export function UserSelect(props: {
  id: string;
  name: string;
  label: any;
  setValueFunction: Function;
  errorMessage: string;
  hasErrors: boolean;
  multiple: boolean;
  assigneeTaskSetMatchingCriteria?: number;
  defaultValue?: Option;
}) {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: userSelectSaga });

  const dispatch = useDispatch();
  const users = useSelector(selectUsersData);
  const [userOptions, setUserOptions] = useState([] as Option[]);

  function userToOption(users: User[]): Option[] {
    const userOptions: Option[] = [];
    users.forEach(user => {
      userOptions.push({ value: user.id, text: user.name } as Option);
    });
    return userOptions;
  }

  useEffect(() => {
    if (props.defaultValue) {
      setUserOptions([...userOptions, props.defaultValue]);
    }
    // eslint-disable-next-line
  }, [props.defaultValue]);

  useEffect(() => {
    if (users) {
      const unselectedUserOptions = userToOption(users);
      const selectedUsers = userOptions.filter(option => option.selected);

      setUserOptions([
        ...selectedUsers,
        ...unselectedUserOptions.filter(
          option => !selectedUsers.some(selectedUserOption => selectedUserOption.value === option.value),
        ),
      ]);
    }
    // eslint-disable-next-line
    }, [users]);

  const [searchTerm, setSearchTerm] = useState('');
  useEffect(() => {
    dispatch(
      userSelectActions.getUsers({
        name: searchTerm,
        itemsPerPage: null,
        assigneeTaskSetMatchingCriteria: props.assigneeTaskSetMatchingCriteria
          ? props.assigneeTaskSetMatchingCriteria
          : null,
      }),
    );
    // eslint-disable-next-line
  }, [dispatch, searchTerm]);

  function handleOnChangeUser(options: Option[]) {
    const newSelectedOptions: Option[] = options.map(option => {
      return { ...option, selected: true };
    });
    if (props.multiple) {
      const userIds: string[] = [];
      newSelectedOptions.forEach(user => {
        if (user.selected) {
          userIds.push(user.value as string);
        }
      });
      props.setValueFunction(props.name, userIds);
    } else {
      props.setValueFunction(props.name, newSelectedOptions[0]?.value ? newSelectedOptions[0].value : null);
    }

    setUserOptions([
      ...newSelectedOptions,
      ...userOptions
        .filter(option => !newSelectedOptions.some(selectedUserOption => selectedUserOption.value === option.value))
        .map(option => {
          return { ...option, selected: false };
        }),
    ]);
  }

  return (
    <CMultiSelect
      id={props.id}
      label={props.label}
      options={userOptions}
      onFilterChange={searchTerm => setSearchTerm(searchTerm)}
      onChange={options => handleOnChangeUser(options)}
      feedback={props.errorMessage}
      invalid={props.hasErrors}
      multiple={props.multiple}
    />
  );
}

export default UserSelect;
