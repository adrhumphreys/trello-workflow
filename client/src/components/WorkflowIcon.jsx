import React from 'react';

const path = `
  M425.1,31H87.4c-31.1,0-56.4,25.2-56.4,56.2c-0.1,0,0-4,0,337.5c0,31,25.2,56.2,56.2,56.2H425
  c30.9-0.2,55.9-25.3,55.9-56.2V87.2C481.1,56.3,456.1,31.2,425.1,31L425.1,31z
  M229,371.8c-0.2,14.8-12.2,26.7-27,26.7h-83.1
  c-14.9,0.1-27-11.9-27.1-26.7V116.5c0-14.9,12.1-27,27-27H202c14.9,0,27,12.1,27,27v255.3H229z
  M422.9,259.3c0,14.9-12.1,27-27,27
  h-81.4c-14.9,0-27-12.1-27-27V116.6c0-14.9,12.1-27,26.9-27h81.5c14.9,0,27,12.1,27,27V259.3z`;

export default ({ size }) => {
  const sizing = size ? { height: size, width: size } : {};
  const svgProps = {
    xmlns: 'http://www.w3.org/2000/svg',
    x: '0',
    y: '0',
    enableBackground: 'new 0 0 512 512',
    version: '1.1',
    viewBox: '0 0 512 512',
    xmlSpace: 'preserve',
    ...sizing
  };

  return (
    <svg {...svgProps}>
      <path d={path} />
    </svg>
  );
};
