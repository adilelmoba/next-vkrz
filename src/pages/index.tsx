import React from 'react';
import Head from 'next/head';

type indexProps = {};

const index:React.FC<indexProps> = () => {
  
  return (
    <>
      <Head>
        <title>My App Title</title>
      </Head>
      <div className='text-3xl font-bold underline text-emerald-900'>
        Have a good coding
      </div>
    </>
  )
}
export default index;