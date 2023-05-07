import sys

from sympy import *
from sympy.parsing.latex import parse_latex



x = sys.argv[1]
y = sys.argv[2]


expr1 = parse_latex(x)
expr2 = parse_latex(y)

rounded_expr1 = expr1

rounded_expr2 = expr2

for a in preorder_traversal(expr1):
    if isinstance(a, Float):
        rounded_expr1 = expr1.subs(a, round(a, 4))




for a in preorder_traversal(expr2):
    if isinstance(a, Float):
        rounded_expr2 = expr2.subs(a, round(a, 4))


print(rounded_expr1.equals(rounded_expr2))




#
# solution = parse_latex(x)
# given_solution = parse_latex(y)
#
# print(solution.equals(given_solution))


