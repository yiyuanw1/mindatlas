import React, { useEffect, useState } from "react";
import axios from "axios";
import { Enrolment, fetchEnrolments } from "../action/enrolment";
import { EnrolmentTable } from "./Enrolment";

function Homepage() {
  const [enrolments, setEnrolments] = useState<Enrolment[]>([]);

  useEffect(() => {

  }, [])

  useEffect(() => {
    const source = axios.CancelToken.source();
    console.log("fetching");

    fetchEnrolments(undefined, {
      cancelToken: source.token,
    })
      .then((enrolments) => setEnrolments(enrolments))
      .catch((err) => {
        if (axios.isCancel(err)) {
        } else console.log(err);
      });

    return () => source.cancel();
  }, []);

  return (
    <div className="w-75 mx-auto mt-5">
      <h2 className="text-center text-secondary bg-light">Enrolment List</h2>
      <EnrolmentTable enrolments={enrolments} />
    </div>
  );
}

export default Homepage;
