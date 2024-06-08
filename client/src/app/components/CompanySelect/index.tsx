import React, { useEffect, useState } from 'react';
import { CMultiSelect } from '@coreui/react-pro';
import { Option } from '@coreui/react-pro/dist/components/multi-select/types';
import { useDispatch, useSelector } from 'react-redux';
import { Company, CompanySearch } from '../../../types/Company';
import { useInjectReducer, useInjectSaga } from 'redux-injectors';
import { companySelectSaga } from './saga';
import { selectCompaniesData } from './selectors';
import { companySelectActions, reducer, sliceKey } from './slice';

export function CompanySelect(props: {
  id: string;
  name: string;
  label: any;
  setValueFunction: Function;
  errorMessage: string;
  hasErrors: boolean;
  multiple: boolean;
}) {
  useInjectReducer({ key: sliceKey, reducer: reducer });
  useInjectSaga({ key: sliceKey, saga: companySelectSaga });

  const dispatch = useDispatch();
  const companies = useSelector(selectCompaniesData);
  const [companyOptions, setCompanyOptions] = useState([] as Option[]);

  function companyToOption(companies: Company[]): Option[] {
    const companyOptions: Option[] = [];
    companies.forEach(company => {
      companyOptions.push({ value: company.id, text: company.name } as Option);
    });
    return companyOptions;
  }

  useEffect(() => {
    if (companies) {
      const unselectedCompanyOptions = companyToOption(companies);
      const selectedCompanies = companyOptions.filter(option => option.selected);

      setCompanyOptions([
        ...selectedCompanies,
        ...unselectedCompanyOptions.filter(
          option => !selectedCompanies.some(selectedCompanyOption => selectedCompanyOption.value === option.value),
        ),
      ]);
    }
    // eslint-disable-next-line
  }, [companies]);

  const [searchTerm, setSearchTerm] = useState('');
  useEffect(() => {
    dispatch(
      companySelectActions.getCompanies({
        name: searchTerm,
        itemsPerPage: null,
        administrativeDisabled: false,
      } as CompanySearch),
    );
  }, [dispatch, searchTerm]);

  function handleOnChangeCompany(options: Option[]) {
    const newSelectedOptions: Option[] = options.map(option => {
      return { ...option, selected: true };
    });
    if (props.multiple) {
      const companyIds: string[] = [];
      newSelectedOptions.forEach(company => {
        if (company.selected) {
          companyIds.push(company.value as string);
        }
      });
      props.setValueFunction(props.name, companyIds);
    } else {
      props.setValueFunction(props.name, newSelectedOptions[0]?.value ? newSelectedOptions[0].value : null);
    }

    setCompanyOptions([
      ...newSelectedOptions,
      ...companyOptions
        .filter(
          option => !newSelectedOptions.some(selectedCompanyOption => selectedCompanyOption.value === option.value),
        )
        .map(option => {
          return { ...option, selected: false };
        }),
    ]);
  }

  return (
    <CMultiSelect
      id={props.id}
      label={props.label}
      options={companyOptions}
      onFilterChange={searchTerm => setSearchTerm(searchTerm)}
      onChange={options => handleOnChangeCompany(options)}
      feedback={props.errorMessage}
      invalid={props.hasErrors}
      multiple={props.multiple}
    />
  );
}

export default CompanySelect;
