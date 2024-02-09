import React, { useEffect, useState } from "react";
import {
  Enrolment,
  fetchEnrolmentCount,
  fetchEnrolments,
} from "../action/enrolment";
import { Table } from "react-bootstrap";
import axios from "axios";
import ReactPaginate from "react-paginate";

const ROWS_PER_PGAE = 20;

const STATUS_COLOR = {
  "not started": "danger",
  "in progress": "warning",
  completed: "success",
};

export const EnrolmentTable = ({
  filter,
  search,
}: {
  filter: { course?: number; user?: number };
  search?: string;
}) => {
  const [enrolments, setEnrolments] = useState<Enrolment[]>([]);
  const [rowCount, setRowCount] = useState<number>(0);
  const [page, setPage] = useState<number>(0);

  useEffect(() => {
    fetchEnrolmentCount({ filter, search })
      .then(({ count }) => setRowCount(count))
      .catch((err) => console.log(err));
  }, [search, filter]);

  useEffect(() => {
    setPage(0);
  }, [search, filter])

  useEffect(() => {
    const source = axios.CancelToken.source();

    fetchEnrolments(
      {
        page,
        filter,
        search,
      },
      {
        cancelToken: source.token,
      }
    )
      .then((enrolments) => setEnrolments(enrolments))
      .catch((err) => {
        if (axios.isCancel(err)) {
        } else console.log(err);
      });

    return () => source.cancel();
  }, [page, filter, search]);

  return (
    <>
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Course</th>
            <th>Description</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          {enrolments.map((enrolment, i) => (
            <tr key={i}>
              <td>{enrolment.ID}</td>
              <td>
                {enrolment.firstname} {enrolment.surname}
              </td>
              <td>{enrolment.title}</td>
              <td>{enrolment.description}</td>
              <td>
                <span
                  className={`text-${STATUS_COLOR[enrolment.status]
                    }`}
                >
                  {enrolment.status
                    .split(" ")
                    .map(
                      (w) =>
                        w[0].toUpperCase() + w.slice(1)
                    )
                    .join(" ")}
                </span>
              </td>
            </tr>
          ))}
        </tbody>
      </Table>
      {rowCount > 20 && (
        <ReactPaginate
          pageCount={Math.ceil(rowCount / ROWS_PER_PGAE)}
          breakLabel="..."
          previousLabel="< previous"
          nextLabel="next >"
          onPageChange={(e) => {
            setPage(e.selected);
          }}
          forcePage={page}
          pageRangeDisplayed={3}
          marginPagesDisplayed={3}
          containerClassName="pagination justify-content-center"
          pageClassName="page-item"
          pageLinkClassName="page-link"
          previousClassName="page-item"
          previousLinkClassName="page-link"
          nextClassName="page-item"
          nextLinkClassName="page-link"
          breakClassName="page-item"
          breakLinkClassName="page-link"
          activeClassName="page-item active"
          disabledClassName="page-item disabled"
        />
      )}
    </>
  );
};
