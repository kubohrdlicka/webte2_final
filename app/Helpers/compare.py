import sys

from sympy import *
from sympy.parsing.latex import parse_latex



expr1 = sys.argv[1]
expr2 = sys.argv[2]

expr1 = parse_latex(expr1)
expr2 = parse_latex(expr2)




rounded_expr1 = expr1

rounded_expr2 = expr2

for a in preorder_traversal(expr1):
    if isinstance(a, Float):
        rounded_expr1 = expr1.subs(a, round(a, 4))




for a in preorder_traversal(expr2):
    if isinstance(a, Float):
        rounded_expr2 = expr2.subs(a, round(a, 4))

rounded_expr1 = sympify(rounded_expr1)
rounded_expr2 = sympify(rounded_expr2)

print(rounded_expr1.equals(rounded_expr2))